# Pools, lanes, and message flows

Load [SKILL.md](SKILL.md) first. Use this when a diagram has more than one participant, lanes, or message flows between pools. Message configuration (declarations, payload, receivers) is in [events.md](events.md#messages-declaration-targeting-and-payload). Fixture: [examples/message-collaboration.bpmn.xml](examples/message-collaboration.bpmn.xml).

## Identity

| | Pool | Lane |
|--|------|------|
| Modeler id | `processmaker-modeler-pool` | `processmaker-modeler-lane` |
| BPMN type | `bpmn:participant` | `bpmn:lane` |
| Palette | Yes | No. Created from the pool's crown menu |
| Configuration | Name, id, documentation only | Name, id, documentation only |

Pools live under a `bpmn:collaboration`. Each participant references a `bpmn:process` through `processRef`. Lanes go in that process's `laneSet`, with `flowNodeRef` children.

There is no `pm:config` and no `implementation` on a pool or lane.

## Inspector fields

| Field | Attribute | Required |
|-------|-----------|----------|
| Name | `name` | Yes |
| Node identifier | `id` | Yes (Advanced) |
| Documentation | `bpmn:documentation` child | No |

## Rules

1. A diagram with several pools has a `bpmn:collaboration` with one participant per pool.
2. Executable work stays in the process that owns the flow nodes. Set `isExecutable` on the process that must run.
3. Links between pools are `bpmn:messageFlow`, never `bpmn:sequenceFlow`. A sequence flow stays inside one process or pool. See [gateways.md](gateways.md#sequence-flows-versus-message-flows).
4. Put each flow node in the process of the pool that owns it. When lanes are used, list the node in a lane's `flowNodeRef`.
5. Include diagram shapes and edges (`BPMNShape`, `BPMNEdge`) for participants, lanes, and flows. A large pool shape defaults to about 600 by 300.
6. A message flow line does not transfer data on its own. Configure the `messageRef` declarations and data mappings on the events.

## Minimal sketch

```xml
<bpmn:collaboration id="collaboration_0">
  <bpmn:participant id="node_pool_a" name="Applicant" processRef="Process_A" />
  <bpmn:participant id="node_pool_b" name="Back Office" processRef="Process_B" />
  <bpmn:messageFlow id="mf_1" sourceRef="node_task_a" targetRef="node_task_b" />
</bpmn:collaboration>
<bpmn:process id="Process_A" isExecutable="true">
  <bpmn:laneSet>
    <bpmn:lane id="node_lane_a" name="Submit">
      <bpmn:flowNodeRef>node_task_a</bpmn:flowNodeRef>
    </bpmn:lane>
  </bpmn:laneSet>
  <!-- start, tasks, end for Process_A -->
</bpmn:process>
<bpmn:process id="Process_B" isExecutable="false">
  <!-- counterpart process -->
</bpmn:process>
```

## Failures

| Symptom | Cause |
|---------|-------|
| The pool is treated like a task | A pool is a participant with a `processRef`, not an activity |
| The flow between pools is rejected or does nothing | A `sequenceFlow` was used. Use `messageFlow` |
| A node is missing from the lane view | It is not listed in any lane's `flowNodeRef` |
| Pool or lane is invisible or collapsed | Missing or too small diagram bounds |
